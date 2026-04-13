ld = childAfter(child);
      }
      return true;
    }());
  }

  @override
  bool hitTestChildren(BoxHitTestResult result, {required Offset position}) {
    final (double mainAxisPosition, double crossAxisPosition) = switch (axis) {
      Axis.vertical => (position.dy, position.dx),
      Axis.horizontal => (position.dx, position.dy),
    };
    final SliverHitTestResult sliverResult = SliverHitTestResult.wrap(result);
    for (final RenderSliver child in childrenInHitTestOrder) {
      if (!child.geometry!.visible) {
        continue;
      }
      final Matrix4 transform = Matrix4.identity();
      applyPaintTransform(child, transform); // must be invertible
      final bool isHit = result.addWithOutOfBandPos