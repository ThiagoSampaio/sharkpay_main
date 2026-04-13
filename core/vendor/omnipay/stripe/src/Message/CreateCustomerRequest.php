is governed by a BSD-style license that can be
// found in the LICENSE file.

/// @docImport 'package:flutter/semantics.dart';
/// @docImport 'package:flutter/widgets.dart';
/// @docImport 'package:flutter_test/flutter_test.dart';
library;

import 'dart:io' show Platform;
import 'dart:ui' as ui show FlutterView, Scene, SceneBuilder, SemanticsUpdate;

import 'package:flutter/foundation.dart';
import 'package:flutter/services.dart';

import 'binding.dart';
import 'box.dart';
import 'debug.dart';
import 'layer.dart';
import 'object.dart';

/// The layout constraints for the root render object.
@immutable
class ViewConfiguration {
  /// Creates a view configuration.
  ///
  /// By default, the view has [logicalConstraints] and [physicalConstraints]
  /// with all dimensions set to zero (i.e. the view is forced to [Size.zero])
  /// and a [devicePixelRatio] of 1.0.
  ///
  /// [ViewConfiguration.fromView] is a more convenient way for deriving a
  /// [ViewConfiguration] from a given [ui.FlutterView].
  const ViewConfiguration({
    this.physicalConstraints = const BoxConstraints(maxWidth: 0, maxHeight: 0),
    this.logicalConstraints = const BoxConstraints(maxWidth: 0, maxHeight: 0),
    this.devicePixelRatio = 1.0,
  });

  /// Creates a view configuration for the provided [ui.FlutterView].
  factory ViewConfiguration.fromView(ui.FlutterView view) {
    final BoxConstraints physicalConstraints = BoxConstraints.fromViewConstraints(
      view.physicalConstraints,
    );
    final double devicePixelRatio = view.devicePixelRatio;
    return ViewConfiguration(
      physicalConstraints: physicalConstraints,
      logicalConstraints: physicalConstraints / devicePixelRatio,
      devicePixelRatio: devicePixelRatio,
    );
  }

  /// The constraints of the output surface in logical pixel.
  ///
  /// The constraints are passed to the child of the root render object.
  final BoxConstraints logicalConstraints;

  /// The constraints of the output surface in physical pixel.
  ///
  /// These constraints are enforced in [toPhysicalSize] when translating
  /// the logical size of the root render object back to physical pixels for
  /// the [ui.FlutterView.render] method.
  final BoxConstraints physicalConstraints;

  /// The pixel density of the output surface.
  final double devicePixelRatio;

  /// Creates a transformation matrix that applies the [devicePixelRatio].
  ///
  /// The matrix translates points from the local coordinate system of the
  /// app (in logical pixels) to the global coordinate system of the
  /// [ui.FlutterView] (in physical pixels).
  Matrix4 toMatrix() {
    return Matrix4.diagonal3Values(devicePixelRatio, devicePixelRatio, 1.0);
  }

  /// Returns whether [toMatrix] would return a different value for this
  /// configuration than it would for the given `oldConfiguration`.
  bool shouldUpdateMatrix(ViewConfiguration oldConfiguration) {
    if (oldConfiguration.runtimeType != runtimeType) {
      // New configuration could have different logic, so we don't know
      // whether it will need a new transform. Return a conservative result.
      return true;
    }
    // For this class, the only input to toMatrix is the device pixel ratio,
    // so we return true if they differ and false otherwise.
    return oldConfiguration.devicePixelRatio != devicePixelRatio;
  }

  /// Transforms the provided [Size] in logical pixels to physical pixels.
  ///
  /// The [ui.FlutterView.render] method accepts only sizes in physical pixels, but
  /// the framework operates in logical pixels. This method is used to transform
  /// the logical size calculated for a [RenderView] back to a physical size
  /// suitable to be passed to [ui.FlutterView.render].
  ///
  /// By default, this method just multiplies the provided [Size] with the
  /// [devicePixelRatio] and constraints the results to the
  /// [physicalConstraints].
  Size toPhysicalSize(Size logicalSize) {
    return physicalConstraints.constrain(logicalSize * devicePixelRatio);
  }

  @override
  bool operator ==(Object other) {
    if (other.runtimeType != runtimeType) {
      return false;
    }
    return other is ViewConfiguration &&
        other.logicalConstraints == logicalConstraints &&
        other.physicalConstraints == physicalConstraints &&
        other.devicePixelRatio == devicePixelRatio;
  }

  @override
  int get hashCode => Object.hash(logicalConstraints, physicalConstraints, devicePixelRatio);

  @override
  String toString() => '$logicalConstraints at ${debugFormatDouble(devicePixelRatio)}x';
}

/// The root of the render tree.
///
/// The view represents the total output surface of the render tree and handles
/// bootstrapping the rendering pipeline. The view has a unique child
/// [RenderBox], which is required to fill the