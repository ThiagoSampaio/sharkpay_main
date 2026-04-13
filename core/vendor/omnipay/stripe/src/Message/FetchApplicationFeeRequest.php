vot), rect);
    } else if (onlySlivers) {
      // `pivot` does not exist. We'll have to make up one from `target`, the
      // innermost sliver.
      final RenderSliver targetSliver = target as RenderSliver;
      growthDirection = targetSliver.constraints.growthDirection;
      // TODO(LongCatIsLooong): make sure this works if `targetSliver` is a
      // persistent header, when #56413 relands.
      pivotExtent = targetSliver.geometry!.scrollExtent;
      if (rect == null) {
        switch (axis) {
          case Axis.horizontal:
            rect = Rect.fromLTWH(
              0,
              0,
              targetSliver.geometry!.scrollExtent,
              targetSliver.constraints.crossAxisExtent,
            );
          case Axis.vertical:
            rect = Rect.fromLTWH(
              0,
              0,
              targetSliver.constraints.crossAxisExtent,
              targetSliver.geometry!.scrollExtent,
            );
        }
      }
      rectLocal = rect;
    } else {
      assert(rect != null);
      return RevealedOffset(offset: offset.pixels, rect: rect!);
    }

    assert(child.parent == this);
    assert(child is RenderSliver);
    final RenderSliver sliver = child as RenderSliver;

    // The scroll offset of `rect` within `child`.
    leadingScrollOffset += switch (applyGrowthDirectionToAxisDirection(
      axisDirection,
      growthDirection,
    )) {
      AxisDirection.up => pivotExtent - rectLocal.bottom,
      AxisDirection.left => pivotExtent - rectLocal.right,
      AxisDirection.right => rectLocal.left,
      AxisDirection.do